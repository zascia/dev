import React from 'react';
import s from './Navbar.module.css';
import {NavLink} from "react-router-dom";

const Navbar = (props) => {
    let navlinkElements = props.state
        .map(el => <NavLink to={`/${el.path}`} activeClassName={s.activeLink}>{el.title}</NavLink>)

    return <nav className={s.nav}>
        <div className={s.item}>
            { navlinkElements }
        </div>
    </nav>
}

export default Navbar;