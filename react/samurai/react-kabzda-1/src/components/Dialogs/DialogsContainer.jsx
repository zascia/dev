import React from 'react';
import {addMessageActionCreator, updateNewDialogTextActionCreator} from '../../redux/dialogs-reducer';
import Dialogs from './Dialogs';
import StoreContext from '../../StoreContext';

const DialogsContainer = () => {

    return (
        <StoreContext.Consumer>
            {store => {
                let state = store.getState().dialogsPage;

                let addMessage = () => {
                    store.dispatch(addMessageActionCreator());
                };

                let onDialogChange = (text) => {
                    store.dispatch(updateNewDialogTextActionCreator(text));
                };

                return (
                    <Dialogs updateNewMessageBody={onDialogChange} addMessage={addMessage} dialogsPage={state}/>
                )
            }
            }
        </StoreContext.Consumer>
    );
};

export default DialogsContainer;