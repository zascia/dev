import React from 'react';
import './App.css';
import Header from './components/Header/Header';
import News from './components/News/News';
import Music from './components/Music/Music';
import Settings from './components/Settings/Settings';
import {BrowserRouter, Route} from 'react-router-dom';
import DialogsContainer from './components/Dialogs/DialogsContainer';
import SidebarContainer from './components/Sidebar/SidebarContainer';
import UsersContainer from './components/Users/UsersContainer';
import ProfileContainer from './components/Profile/ProfileContainer';

const App = (props) => {
    return (
        <div className='app-wrapper'>
          <Header />
          <SidebarContainer />
          <div className='app-wrapper-content'>
              <Route path='/dialogs' render={ () => <DialogsContainer /> } />
              <Route path='/profile/:userId?' render={ () => <ProfileContainer /> } />
              <Route path='/users' render={ () => <UsersContainer /> } />
              <Route path='/news' component={News} />
              <Route path='/music' component={Music} />
              <Route path='/settings' component={Settings} />
          </div>
        </div>
      );
}

export default App;