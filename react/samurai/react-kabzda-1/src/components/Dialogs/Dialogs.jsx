import React from 'react';
import s from './Dialogs.module.css';
import {NavLink} from "react-router-dom";

const DialogItem = (props) => {
    let path = "/dialogs/" + props.id;
    return <div className={s.dialog + ' ' + s.active}>
        <NavLink to={path}>{props.name}</NavLink>
    </div>
}

const Message = (props) => {
    return <div className={s.message}>{props.message}</div>
}

const Dialogs = (props) => {
    let dialogsData = [
        {id:1,name:'Andrey'},
        {id:2,name:'Sasha'},
        {id:3,name:'Victor'},
        {id:4,name:'Misha'},
        {id:5,name:'Leonid'},
        {id:6,name:'Leopard'}
    ]

    let messagesData = [
        {id:1,message:'Hi'},
        {id:2,message:'How are you'},
        {id:3,message:'Yo'},
        {id:4,message:'Yo'},
        {id:5,message:'Yo'}
    ]

    return (
        <div className={s.dialogs}>
            <div className={s.dialogsItems}>
                <DialogItem name={dialogsData[0].name} id={dialogsData[0].id} />
                <DialogItem name="Sasha" id="2" />
                <DialogItem name="Victor" id="3" />
                <DialogItem name="Misha" id="4" />
                <DialogItem name="Leonid" id="5" />
                <DialogItem name="Leopard" id="6" />
            </div>
            <div className={s.messages}>
                <Message message={messagesData[0].message} />
                <Message message="How are you" />
                <Message message="Yo" />
                <Message message="Yo" />
            </div>
        </div>
    )
}

export default Dialogs;