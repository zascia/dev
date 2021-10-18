import React from 'react';
import {addMessage, updateNewMessageBody} from '../../redux/dialogs-reducer';
import Dialogs from './Dialogs';
import {connect} from 'react-redux';
import {compose} from 'redux';
import {withAuthRedirect} from '../../hoc/withAuthRedirect';

let mapStateToProps = (state) => {
    return {
        dialogsPage: state.dialogsPage
    };
};

/*
let AuthRedirectComponent = withAuthRedirect(Dialogs);

const DialogsContainer = connect(mapStateToProps, {updateNewMessageBody, addMessage})(AuthRedirectComponent);
*/

export default compose(
    connect(mapStateToProps, {updateNewMessageBody, addMessage}),
    withAuthRedirect
)(Dialogs);