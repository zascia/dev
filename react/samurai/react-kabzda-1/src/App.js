import React from 'react';
import './App.css';
import Header from './components/Header/Header';
import Sidebar from './components/Sidebar/Sidebar';
import Profile from './components/Profile/Profile';
import News from './components/News/News';
import Music from './components/Music/Music';
import Settings from './components/Settings/Settings';
import {BrowserRouter, Route} from "react-router-dom";
import DialogsContainer from "./components/Dialogs/DialogsContainer";

const App = (props) => {
    return (
        <div className='app-wrapper'>
          <Header />
          <Sidebar state={props.state.sidebarSection} />
          <div className='app-wrapper-content'>
              <Route path='/dialogs' render={ () => <DialogsContainer store={props.store} /> } />
              <Route path='/profile' render={ () => <Profile store={props.store} /> } />
              <Route path='/news' component={News} />
              <Route path='/music' component={Music} />
              <Route path='/settings' component={Settings} />
          </div>
        </div>
      );
}

export default App;