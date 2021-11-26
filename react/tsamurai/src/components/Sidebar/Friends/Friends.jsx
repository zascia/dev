import React from 'react';
import s from './Friends.module.css';
import {NavLink} from "react-router-dom";
import FriendItem from "./FriendItem/FriendItem";

const Friends = (props) => {
    let friendsList = props.state
        .map(el => <FriendItem id={el.id} name={el.name} age={el.age} key={el.id} />)

    return (
        <div className="FriendsSection">
            <h2>Friends list</h2>
            <ul>
                { friendsList }
            </ul>
        </div>
    )
}

export default Friends;