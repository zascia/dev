import React from 'react';
import {NavLink} from "react-router-dom";

const FriendItem = (props) => {
    let path = "/friends/" + props.id;

    return (
        <li>
            <NavLink to={path}>Name: {props.name} Age: {props.age}</NavLink>
        </li>
    )
}

export default FriendItem;