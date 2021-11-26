type FriendType = {
    id: number
    name: string
    age: number
}
type NavLinkType = {
    id: number
    path: string
    title: string
}

let initialState = {
    friends: [
        {id:1,name:'Ivan',age:23},
        {id:2,name:'Oleks',age:32},
        {id:3,name:'Mavr',age:33}
    ] as Array<FriendType>,
    navlinks: [
        {id:1,path:'profile',title:'Profile'},
        {id:2,path:'dialogs',title:'Messages'},
        {id:3,path:'users',title:'Users'},
        {id:4,path:'news',title:'News'},
        {id:5,path: 'music',title:'Music'},
        {id:6,path:'settings',title:'Settings'}
    ] as Array<NavLinkType>
}

export type InitialStateType = typeof initialState;

const sidebarReducer = (state = initialState, action: any): InitialStateType => {
    return state;
}

export default sidebarReducer;