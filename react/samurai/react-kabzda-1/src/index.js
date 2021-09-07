import * as serviceWorker from './serviceWorker';
import state, {subscribe} from './redux/state'

//
import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import {addPost, updateNewPostText, addMessage, updateNewDialogText} from "./redux/state";

let renderEntireTree = (state) => {
    ReactDOM.render(<App state={state} addPost={addPost} updateNewPostText={updateNewPostText} addMessage={addMessage} updateNewDialogText={updateNewDialogText} />, document.getElementById('root'));
}
//

renderEntireTree(state);

subscribe(renderEntireTree);


// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: http://bit.ly/CRA-PWA
serviceWorker.unregister();
