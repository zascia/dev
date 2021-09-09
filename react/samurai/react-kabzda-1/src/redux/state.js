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
    getState() {
        return this._state;
    },
    _callSubscriber() {
        console.log('state changed')
    },
    addPost() {
        let newPost = {
            id: 5,
            message: this._state.profilePage.newPostText,
            likesCount: 0
        }
        this._state.profilePage.posts.push(newPost);
        this._state.profilePage.newPostText = '';
        this._callSubscriber(this._state);
    },
    updateNewPostText(newText) {
        this._state.profilePage.newPostText = newText;
        this._callSubscriber(this._state);
    },
    addMessage() {
        let newMessage = {
            id: 6,
            message: this._state.dialogsPage.newDialogText
        }
        this._state.dialogsPage.messages.push(newMessage);
        this._state.dialogsPage.newDialogText = '';
        this._callSubscriber(this._state);
    },
    updateNewDialogText(newText) {
        this._state.dialogsPage.newDialogText = newText;
        this._callSubscriber(this._state);
    },
    subscribe(observer) {
        this._callSubscriber = observer;
    }
}

export default store;
window.store = store;