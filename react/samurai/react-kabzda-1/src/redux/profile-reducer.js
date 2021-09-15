const ADD_POST = 'ADD-POST';
const UPDATE_NEW_POST_TEXT = 'UPDATE-NEW-POST-TEXT';

let initialState = {
    posts: [
        {id:1,message:'Hi, how are you?', likesCount: 32},
        {id:2,message:'It\'s my first post', likesCount: 132}
    ],
    newPostText: 'hello it--kamasutra.com'
}

const profileReducer = (state = initialState,action) => {
    // this._state.profilePage = state
    switch (action.type) {
        case ADD_POST:
            let newPost = {
                id: 5,
                message: state.newPostText,
                likesCount: 0
            }
            state.posts.push(newPost);
            state.newPostText = '';
            break;
        case UPDATE_NEW_POST_TEXT:
            state.newPostText = action.newText;
            break;
    }

    return state;
}

export const addPostActionCreator = () => ({type: ADD_POST})
export const updateNewPostTextActionCreator = (text) => ({type: UPDATE_NEW_POST_TEXT,newText: text})


export default profileReducer;