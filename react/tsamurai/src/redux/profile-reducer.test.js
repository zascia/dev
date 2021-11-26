import profileReducer, {addPost, deletePost} from './profile-reducer';

let state = {
    posts: [
        {id:1,message:'Hi, how are you?', likesCount: 32},
        {id:2,message:'It\'s my first post', likesCount: 132}
    ]
};

it('number of posts should be incremented', ()=>{
    // 1. test data
    let action = addPost("it-camasutra.com");

    // 2. action
    let newState = profileReducer(state, action);

    // 3. expectation
    expect(newState.posts.length).toBe(3);
});

it('message of new post should be correct', ()=>{
    // 1. test data
    let action = addPost("it-camasutra.com");

    // 2. action
    let newState = profileReducer(state, action);

    // 3. expectation
    expect(newState.posts[2].message).toBe("it-camasutra.com");
});

it('after deleting length of messages should be decremented', ()=>{
    // 1. test data
    let action = deletePost(2);

    // 2. action
    let newState = profileReducer(state, action);

    // 3. expectation
    expect(newState.posts.length).toBe(1);
});

it(`after deleting length of messages shouldn't be decremented if id is incorrect`, ()=>{
    // 1. test data
    let action = deletePost(1000);

    // 2. action
    let newState = profileReducer(state, action);

    // 3. expectation
    expect(newState.posts.length).toBe(2);
})

