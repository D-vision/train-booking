import './bootstrap';

const files = require.context('./pages', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0],
    files(key).default)
)

window.app = new Vue({
    el:'#app'
})
