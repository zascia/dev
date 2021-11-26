import React from 'react';
import {connect} from 'react-redux';
import Sidebar from './Sidebar';

let mapStateToProps = (state) => {
    return {
        navlinks: state.sidebarSection.navlinks,
        friends: state.sidebarSection.friends
    };
};

let mapDispatchToProps = () => {
    return {};
};

const SidebarContainer = connect(mapStateToProps,mapDispatchToProps)(Sidebar);

export default SidebarContainer;