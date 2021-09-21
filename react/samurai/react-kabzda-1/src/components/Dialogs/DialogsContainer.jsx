import React from 'react';
import {addMessageActionCreator, updateNewDialogTextActionCreator} from "../../redux/dialogs-reducer";
import Dialogs from "./Dialogs";

const DialogsContainer = (props) => {

    let state = props.store.getState().dialogsPage;

    let addMessage = () => {
        props.store.dispatch(addMessageActionCreator());
    };

    let onDialogChange = (text) => {
        props.store.dispatch(updateNewDialogTextActionCreator(text));
    };

    return (
        <Dialogs updateNewMessageBody={onDialogChange} addMessage={addMessage} dialogsPage={state} />
    );
};

export default DialogsContainer;