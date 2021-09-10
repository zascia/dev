import React from 'react';
import s from './Dialogs.module.css';
import DialogItem from "./DialogItem/DialogItem";
import Message from "./Message/Message";

const Dialogs = (props) => {

    let dialogsElements = props.dialogsPage.dialogs
        .map(d => <DialogItem name={d.name} id={d.id} />);

    let messagesElements = props.dialogsPage.messages
        .map( m => <Message message={m.message} />);

    let newMessageElement = React.createRef();
    let sendMessage = () => {
        let action = {type: 'ADD-MESSAGE'};
        props.dispatch(action);
    }

    let onDialogChange = () => {
        let text = newMessageElement.current.value;
        let action = {type: 'UPDATE-NEW-DIALOG-TEXT', newText: text};
        props.dispatch(action);
    }

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
                    <textarea ref={newMessageElement} onChange={onDialogChange} value={props.dialogsPage.newDialogText} />
                </div>
                <div>
                    <button onClick={sendMessage}>Send message</button>
                </div>
            </div>
        </div>
    )
}

export default Dialogs;