function ApiError(error){
    this.source  = error.source || 'default'
    this.message = error.message|| 'Request error'
    this.status  = error.status || 0
    this.data    = error.data   || {}
}

ApiError.prototype = Object.create(Error.prototype);
ApiError.prototype.constructor = ApiError;


export default class {
    constructor({host = '/',axiosInstance}) {
        this.requests = {}
        this.host = host
        this.axios = axiosInstance
        this.timeout = 0
    }

    get(url,params=[]){
        return this.request(url,'get',{params})
    }
    post(url,data={},params=[]){
        return this.request(url,'post',{data,params})
    }
    put(url,params=[]){
        return this.request(url,'put',{params})
    }
    delete(url,params=[]){
        return this.request(url,'delete',{params})
    }

    async request(url,method,req = {params:[],data:{}}){

        let result

         return await this.axios.request({
            url, method,
            baseURL:this.host,
            params:req.params,
            data:req.data,
            timeout:this.timeout,
            // cancelToken: new CancelToken(function (cancel) {}),
        })
        .then(({data,status,statusText}) => {
            return  data
            // 200 OK
            // 201 Created
            // 202 Accepted
            // 203 Non-authoritative Information
            // 204 No Content
            // 205 Reset Content
            // 206 Partial Content
            // 207 Multi-Status
            // 208 Already Reported
            // 226 IM Used
        })
        .catch(error => {
            let def = this.handlerErrors(error)
            throw new ApiError(def);
        })
    }

    handlerErrors(error){
        this.onAnyError()

        if(error.response){
            //access failed
            const accessCodes = [401,402,403,407,423,426,429,451]
            if(accessCodes.indexOf(error.response.status)>=0)
                return this.onAccessFailed()

            //app error
            const appCodes = [400,404,405,406,409,410,411,412,417,421,424,428,431,500,501,502,503,508]
            if(appCodes.indexOf(error.response.status)>=0)
                return this.onAppError(error)

            //data error
            const dataCodes = [422,413,414,415,416]
            if(dataCodes.indexOf(error.response.status)>=0)
                return this.onDataError(error)

            //server error
            const serverCodes = [408,444,499,504,505,506,507,510,511,599]
            if(serverCodes.indexOf(error.response.status)>=0)
                return this.onServerError()

            //teapot
            if(error.response.status === 418)
                return this.onTeapot()

        } else if (error.request){
            return this.onTransportError()
        } else{
            return this.onServerError()
        }
    }
    onReady(data,status){
        // error.toJson()
    }
    onAnyError(error){
        // error.toJson()
        //TODO: log in store log
    }
    onDataError(error){
        // return back for handling
        let data = error.response.data
        return {
            'source':'data',
            'message':data.message?data.message:error.message,
            'status':error.response.status,
            'data':error.response.data,
        }
    }
    onAppError(error){
        // send to controls store to describe user problem and report our support for issue
        let data = error.response.data
        return {
            'source':'app',
            'message':data.message?data.message:error.message,
            'status':error.response.status,
            'data':error.response.data,
        }
    }
    onServerError(error){
        // return back for handling and retrying 60 seconds later
        //TODO: handle globaly
    }
    onAccessFailed(error){
        // send to controls store to offer user:
        // - authorize if loggedout
        // - if restricted
        // -- logout and login to another user
        // -- request admin to provide access to resource
        //TODO: handle globaly - show auth
    }
    onTeapot(error){
        // TODO: easter egg
    }

    onTransportError(error){
        //TODO: handle globaly
        // send to controls store to describe user problem and trying to analyze internet connection and access to server
        // trouble shoot ip
    }
    onSendError(error){
        //TODO: handle globaly
    }

}

