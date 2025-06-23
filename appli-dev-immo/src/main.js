import { createApp } from 'vue' /* demarrage de l'appli vue*/
import App from './App.vue' /*composant principal du projet*/
import router from './router' /*systéme de navigation*/

createApp(App).use(router).mount("#app") 
/*use (router) connexion du systéme de nav à vue / et on attache l'appli à la balise html qui a l'id app*/
