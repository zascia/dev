import loadingIcon from '../../../assets/images/loading_icon.gif';
import React from 'react';

let Preloader = (props) => {
    return <div style={ {backgroundColor: 'white'} }>
        <img src={loadingIcon} />
    </div>
}

export default Preloader;