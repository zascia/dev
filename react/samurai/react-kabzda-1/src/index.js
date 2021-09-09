import * as serviceWorker from './serviceWorker';
import store from './redux/state';
import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';

let state = store.getState();

let renderEntireTree = (state) => {
    ReactDOM.render(<App state={state} addPost={store.addPost.bind(store)} updateNewPostText={store.updateNewPostText.bind(store)} addMessage={store.addMessage.bind(store)} updateNewDialogText={store.updateNewDialogText.bind(store)} />, document.getElementById('root'));
}
//

renderEntireTree(state);

store.subscribe(renderEntireTree);


// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: http://bit.ly/CRA-PWA
serviceWorker.unregister();
