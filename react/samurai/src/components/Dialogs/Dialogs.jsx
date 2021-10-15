import React from 'react';
import s from './Dialogs.module.css';
import DialogItem from "./DialogItem/DialogItem";
import Message from "./Message/Message";
import {Redirect} from "react-router-dom";

const Dialogs = (props) => {

    let state = props.dialogsPage;

    let dialogsElements = state.dialogs
        .map(d => <DialogItem name={d.name} key={d.id} id={d.id} />);

    let messagesElements = state.messages
        .map( m => <Message message={m.message} key={m.id} />);

    let newMessageElement = React.createRef();
    let sendMessage = () => {
        props.addMessage();
    };

    let onDialogChange = () => {
        let text = newMessageElement.current.value;
        props.updateNewMessageBody(text);
    };

    if (!props.isAuth) return <Redirect to="/login" />;

    return (
        <div>
            <div className={s.dialogs}>
                <div className={s.dialogsItems}>
                    { dialogsElements }
                </div>
                <div className={s.messages}>
                    { messagesElements }
                </div>
            </div>
            <div>
                <h3>Send message</h3>
                <div>
                    <textarea ref={newMessageElement} onChange={onDialogChange} value={state.newDialogText} />
                </div>
                <div>
                    <button onClick={sendMessage}>Send message</button>
                </div>
            </div>
        </div>
    )
}

export default Dialogs;