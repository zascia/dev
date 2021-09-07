import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import {addPost, updateNewPostText, addMessage, updateNewDialogText} from "./redux/state";


export let renderEntireTree = (state) => {
    ReactDOM.render(<App state={state} addPost={addPost} updateNewPostText={updateNewPostText} addMessage={addMessage} updateNewDialogText={updateNewDialogText} />, document.getElementById('root'));
}