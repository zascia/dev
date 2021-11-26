import React from 'react';
import s from './Post.module.css';

const Post = (props) => {
    return (
        <div className={s.item}>
            <img className={s.avatar} src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSlZScp_0-ZpzArwb0ib1otBkQx3lkmgxfwdQ&usqp=CAU" />
            {props.message}
            <div><span>likes</span> {props.likesCount}</div>
        </div>
    )
}

export default Post;