<template>
    <div v-if="error" class="panel outline" :class="error.source === 'data'? 'danger':'warning'">
        <div class="heading">{{error.message}}</div>
        <div v-if="error.source==='app'">
            <p>Данные не были сохранены. Проблема на стороне сервера.</p>
            Запрос в тех поддержку
            <div>Автоматически отправить запрос в тех поддержку</div>
        </div>
        <div v-if="error.source==='data'">
            <ul v-for="(err, field) in error.data.errors">
                <li v-for="line in err">{{line}}</li>
            </ul>
        </div>

    </div>
</template>

<script>
export default {
    name: "ErrorPanel",
    props:['error'],
    data(){
        return {
           state:null
        }
    },
    methods:{
        sendIssue(){

        }
    }

}
</script>

<style scoped>

</style>
