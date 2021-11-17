import React from 'react';
import {createField, Input, Textarea} from '../../Common/FormsControls/FormsControls';
import {reduxForm} from 'redux-form';
import s from './ProfileInfo.module.css';
import style from '../../Common/FormsControls/FormsControls.module.css';

const ProfileDataForm = ({handleSubmit, profile, error}) => {
    return <form onSubmit={handleSubmit}>
        <div><button>save</button></div>
        {error && <div className={style.formSummaryError}>
            {error}
        </div>
        }
        <div>
            Full Name: {createField("Full Name", "fullName", [], Input)}
        </div>
        <div>
            Looking for a job:
            {createField("", "lookingForAJob", [], Input, {type: "checkbox"})}
        </div>
        <div>
            My professional skills:
            {createField("My professional skills", "lookingForAJobDescription", [], Textarea )}
        </div>
        <div>
            About me:
            {createField("About me", "aboutMe", [], Textarea )}
        </div>

        <div>
            Contacts: {Object.keys(profile.contacts).map(key => {
            return <div key={key} className={s.contact}>
                <b>{key}:</b> {createField(key, "contacts." + key, [], Input)}
            </div>
        })}
        </div>
    </form>
}

const ProfileDataFormReduxForm = reduxForm({form: 'editProfile'})(ProfileDataForm);

export default ProfileDataFormReduxForm;