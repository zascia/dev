import React from 'react';
import Navbar from "./Navbar/Navbar";
import Friends from "./Friends/Friends";

const Sidebar = (props) => {
    return (
        <div>
            <Navbar state={props.state.navlinks} />
            <Friends state={props.state.friends} />
        </div>
    )
}

export default Sidebar;