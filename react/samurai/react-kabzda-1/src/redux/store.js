import profileReducer from "./profile-reducer";
import dialogsReducer from "./dialogs-reducer";
import sidebarReducer from "./sidebar-reducer";

let store = {
    _state: {
        profilePage: {
            posts: [
                {id:1,message:'Hi, how are you?', likesCount: 32},
                {id:2,message:'It\'s my first post', likesCount: 132}
            ],
            newPostText: 'hello it--kamasutra.com'
        },
        dialogsPage: {
            messages: [
                {id:1,message:'Hiwe'},
                {id:2,message:'How are you'},
                {id:3,message:'Yo'},
                {id:4,message:'Yo'},
                {id:5,message:'Yo'}
            ],
            dialogs: [
                {id:1,name:'Andrey'},
                {id:2,name:'Sasha'},
                {id:3,name:'Victor'},
                {id:4,name:'Misha'},
                {id:5,name:'Leonid'},
                {id:6,name:'Leopard'}
            ],
            newDialogText: 'hi friends'
        },
        sidebarSection: {
            friends: [
                {id:1,name:'Ivan',age:23},
                {id:2,name:'Oleks',age:32},
                {id:3,name:'Mavr',age:33}
            ],
            navlinks: [
                {id:1,path:'profile',title:'Profile'},
                {id:2,path:'dialogs',title:'Messages'},
                {id:3,path:'news',title:'News'},
                {id:4,path:'music',title:'Music'},
                {id:5,path:'settings',title:'Settings'}
            ]
        }
    },
    _callSubscriber() {
        console.log('state changed')
    },
    getState() {
        return this._state;
    },
    subscribe(observer) {
        this._callSubscriber = observer;
    },
    dispatch(action) {

        this._state.profilePage = profileReducer(this._state.profilePage, action);
        this._state.dialogsPage = dialogsReducer(this._state.dialogsPage, action);
        this._state.sidebarSection = sidebarReducer(this._state.sidebarSection, action);

        this._callSubscriber(this._state);
    }
}


export default store;
window.store = store;