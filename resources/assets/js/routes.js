import Home from './components/TouchScreen/Home/Home';
import Agenda from './components/TouchScreen/Agenda/Agenda';
import Expo from './components/TouchScreen/Expo/Expo';
import Events from './components/TouchScreen/Events/Event';
import Map from './components/TouchScreen/Map/Map';
import Social from './components/TouchScreen/Social/Social';
import EWGames from './components/TouchScreen/EWGames/EWGames';




const routes = [
    { path: '/', component: Home },
    { path: '/Agenda', component: Agenda },
    { path: '/Expo', component: Expo },
    { path: '/Events', component: Events },
    { path: '/Map', component: Map },
    { path: '/Social', component: Social },
    { path: '/EW-Games', component: EWGames },




];



export default routes;