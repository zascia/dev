import React from 'react';
import s from './MyPosts.module.css';
import Post from './Post/Post';
import {Field, reduxForm} from 'redux-form';
import {maxLengthCreator, required} from '../../../utils/validators/validators';
import {Textarea} from '../../Common/FormsControls/FormsControls';

let maxLength10 = maxLengthCreator(10);

const MyPosts = (props) => {

    let postsElements = props.posts
        .map(p => <Post message={p.message} key={p.id} likesCount={p.likesCount} />);

    let onAddPost = (values) => {
        props.addPost(values.newPostBody);
    };

    return <div className={s.postsBlock}>
        <h3>My posts</h3>
        <AddPostReduxForm onSubmit={onAddPost} />
        <div className={s.posts}>
            { postsElements }
        </div>
    </div>
}

const AddNewPostForm = (props) => {
    return (
        <form onSubmit={props.handleSubmit}>
            <div>
                <Field component={Textarea} name={"newPostBody"} placeholder={"Enter new post"}
                validate={[required, maxLength10]}/>
            </div>
            <div>
                <button>Add post</button>
            </div>
        </form>
    )
}

const AddPostReduxForm = reduxForm({form: "newPostForm"})(AddNewPostForm);

export default MyPosts;