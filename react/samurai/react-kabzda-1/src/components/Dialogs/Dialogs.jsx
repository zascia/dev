import React from 'react';
import s from './Dialogs.module.css';
import {NavLink} from "react-router-dom";

const Dialogs = (props) => {
    return (
        <div className={s.dialogs}>
            <div className={s.dialogsItems}>
                <div className={s.dialog + ' ' + s.active}>
                    <NavLink to="/dialogs/1">Andrey</NavLink>
                </div>
                <div className={s.dialog}>
                    <NavLink to="/dialogs/2">Sasha</NavLink>
                </div>
                <div className={s.dialog}>
                    <NavLink to="/dialogs/3">Victor</NavLink>
                </div>
                <div className={s.dialog}>
                    <NavLink to="/dialogs/4">Misha</NavLink>
                </div>
                <div className={s.dialog}>
                    <NavLink to="/dialogs/5">Leonid</NavLink>
                </div>
                <div className={s.dialog}>
                    <NavLink to="/dialogs/6">Leopard</NavLink>
                </div>
            </div>
            <div className={s.messages}>
                <div className={s.message}>Hi</div>
                <div className={s.message}>How are you</div>
                <div className={s.message}>Yo</div>
            </div>
        </div>
    )
}

export default Dialogs;