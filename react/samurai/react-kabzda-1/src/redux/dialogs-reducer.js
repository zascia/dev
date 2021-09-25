const ADD_MESSAGE = 'ADD-MESSAGE';
const UPDATE_NEW_DIALOG_TEXT = 'UPDATE-NEW-DIALOG-TEXT';

let initialState = {
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
}

const dialogsReducer = (state = initialState,action) => {

    switch (action.type) {
        case ADD_MESSAGE:
            return {
                ...state,
                messages: [...state.messages, {id: 6, message: state.newDialogText}],
                newDialogText: ''
            }
        case UPDATE_NEW_DIALOG_TEXT:
            return {
                ...state,
                newDialogText: action.newText
            }
        default:
            return state;
    }

}

export const addMessageActionCreator = () => ({type: ADD_MESSAGE})
export const updateNewDialogTextActionCreator = (text) => ({type: UPDATE_NEW_DIALOG_TEXT,newText: text})


export default dialogsReducer;