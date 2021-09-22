import React from 'react';
import Navbar from "./Navbar/Navbar";
import Friends from "./Friends/Friends";
import StoreContext from '../../StoreContext';

const SidebarContainer = () => {
    return (
        <StoreContext.Consumer>
            { store => {
                let state = store.getState();
                return (
                <div>
                    <Navbar state={state.sidebarSection.navlinks}/>
                    <Friends state={state.sidebarSection.friends}/>
                </div> );
            }
            }
        </StoreContext.Consumer>
    )
}

export default SidebarContainer;