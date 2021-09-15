let initialState = {
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

const sidebarReducer = (state = initialState,action) => {
    return state;
}

export default sidebarReducer;