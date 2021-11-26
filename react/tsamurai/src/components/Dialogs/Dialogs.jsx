import React from 'react';
import s from './Dialogs.module.css';
import DialogItem from "./DialogItem/DialogItem";
import Message from "./Message/Message";
import {Redirect} from "react-router-dom";
import {Field, reduxForm} from 'redux-form';
import {Textarea} from '../Common/FormsControls/FormsControls';
import {maxLengthCreator, required} from '../../utils/validators/validators';

let maxLength10 = maxLengthCreator(10);

const Dialogs = (props) => {

    let state = props.dialogsPage;

    let dialogsElements = state.dialogs
        .map(d => <DialogItem name={d.name} key={d.id} id={d.id} />);

    let messagesElements = state.messages
        .map( m => <Message message={m.message} key={m.id} />);

    let addNewMessage = (values) => {
        props.addMessage(values.newMessageBody);
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
                <AddMessageReduxForm onSubmit={addNewMessage} />
            </div>
        </div>
    )
}

const AddMessageForm = (props) => {
    return (
        <form onSubmit={props.handleSubmit}>
            <h3>Send message</h3>
            <div>
                <Field component={Textarea} name={"newMessageBody"} placeholder={"Enter your messsage"}
                validate={[required,maxLength10]}/>
            </div>
            <div>
                <button>Send message</button>
            </div>
        </form>
    )
}

const AddMessageReduxForm = reduxForm({form: 'dialogAddMessageForm'})(AddMessageForm)

export default Dialogs;