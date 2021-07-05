import React from 'react';
import s from './MyPosts.module.css';
import Post from './Post/Post';

const MyPosts = () => {
    return <div>
        My posts
        <div>
            New post
        </div>
        <div className={s.posts}>
            <Post message="Hi, how are you?" like_counts="32" />
            <Post message="It's my first post" like_counts="132" />
        </div>
    </div>
}

export default MyPosts;