import logo from './logo.svg';
import './App.css';

const App = () => {
  return (
      <div className="app-wrapper">
          <header className="header">
            <img src="https://philippines-incognita.com/wp-content/uploads/2021/05/final_logo_short.jpg" />
          </header>
          <nav className="nav">
              <div><a href="#">Profile</a></div>
              <div><a href="#">Messages</a></div>
              <div><a href="#">Contact</a></div>
          </nav>
          <div className="content">
            <div className="big-img"><img src="https://philippines-incognita.com/wp-content/uploads/2021/04/bg.png" /></div>
            <div className="avadescription">Ava + description</div>
            <div className="myPosts">
                My posts
                <div className="NewPost"></div>
                <div className="PostList">
                    <div className="postItem">Post 1</div>
                    <div className="postItem">Post 2</div>
                    <div className="postItem">Post 3</div>
                    <div className="postItem">Post 4</div>
                </div>
            </div>
          </div>
      </div>
  );
}


export default App;
