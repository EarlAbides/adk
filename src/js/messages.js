import Vue from "vue";
import App from "./MessagesApp.vue";

const messages = new Vue({
	el: "#app",
	componentes: App,
	render: h => h(App)
});
