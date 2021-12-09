import {getAuthUserData} from './auth-reducer';
import {AppStateType} from "./redux-store";
import {Dispatch} from "redux";

const INITIALIZED_SUCCESS = 'INITIALIZED_SUCCESS';

export type InitialStateType = {
    initialized: boolean
}
let initialState: InitialStateType = {
    initialized: false
}

const appReducer = (state: InitialStateType = initialState, action: ActionsTypes): InitialStateType => {
    switch (action.type) {
        case INITIALIZED_SUCCESS: {
            return {
                ...state,
                initialized: true
            }
        }
        default:
            return state;
    }
}

type ActionsTypes = InitializedSuccessActionType;

type InitializedSuccessActionType = {
    type: typeof INITIALIZED_SUCCESS
}
export const initializedSuccess = (): InitializedSuccessActionType => ({type: INITIALIZED_SUCCESS});


type GetStateType = () => AppStateType;
type DispatchType = Dispatch<ActionsTypes>;

export const initializeApp = () => (dispatch: DispatchType, getState: GetStateType) => {
    let promiseUserData = dispatch(getAuthUserData());
    promiseUserData
        .then(() => {
            dispatch(initializedSuccess());
        })

}

export default appReducer;