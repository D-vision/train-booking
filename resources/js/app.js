import './bootstrap';
import login from './pages/login'
import home from './pages/home'

window.app = new Vue({
    el:'#app',
    components: {login, home},
    data:{

    }
})
