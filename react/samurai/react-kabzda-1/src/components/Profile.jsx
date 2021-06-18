
const Profile = () => {
    return (
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
    );
}

export default Profile;