let state = {
    profilePage: {
        posts: [
            {id:1,message:'Hi, how are you?', likesCount: 32},
            {id:2,message:'It\'s my first post', likesCount: 132}
        ]
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
        ]
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
}

export default state;