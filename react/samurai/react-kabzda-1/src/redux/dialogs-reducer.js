const ADD_MESSAGE = 'ADD-MESSAGE';
const UPDATE_NEW_DIALOG_TEXT = 'UPDATE-NEW-DIALOG-TEXT';

const dialogsReducer = (state,action) => {

    switch (action.type) {
        case ADD_MESSAGE:
            let newMessage = {
                id: 6,
                message: state.newDialogText
            }
            state.messages.push(newMessage);
            state.newDialogText = '';
            break;
        case UPDATE_NEW_DIALOG_TEXT:
            state.newDialogText = action.newText;
            break;
    }

    return state;
}

export const addMessageActionCreator = () => ({type: ADD_MESSAGE})
export const updateNewDialogTextActionCreator = (text) => ({type: UPDATE_NEW_DIALOG_TEXT,newText: text})


export default dialogsReducer;