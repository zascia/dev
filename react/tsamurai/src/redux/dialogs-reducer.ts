const ADD_MESSAGE = 'ADD-MESSAGE';

type MessageType = {
    id: number
    message: string
}
type DialogType = {
    id: number
    name: string
}

let initialState = {
    messages: [
        {id:1,message:'Hiwe'},
        {id:2,message:'How are you'},
        {id:3,message:'Yo'},
        {id:4,message:'Yo'},
        {id:5,message:'Yo'}
    ] as Array<MessageType>,
    dialogs: [
        {id:1,name:'Andrey'},
        {id:2,name:'Sasha'},
        {id:3,name:'Victor'},
        {id:4,name:'Misha'},
        {id:5,name:'Leonid'},
        {id:6,name:'Leopard'}
    ] as Array<DialogType>
}

export type InitialStateType = typeof initialState;

const dialogsReducer = (state = initialState, action: any): InitialStateType => {

    switch (action.type) {
        case ADD_MESSAGE:
            return {
                ...state,
                messages: [...state.messages, {id: 6, message: action.newText}]
            }
        default:
            return state;
    }

}

type AddMessageActiontype = {
    type: typeof ADD_MESSAGE
    newText: string
}
export const addMessage = (newText: string): AddMessageActiontype => ({type: ADD_MESSAGE,newText})

export default dialogsReducer;