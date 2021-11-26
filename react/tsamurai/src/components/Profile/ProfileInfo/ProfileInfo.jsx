import React, {useState} from 'react';
import s from './ProfileInfo.module.css';
import Preloader from '../../Common/Preloader/Preloader';
import ProfileStatusWithHooks from './ProfileStatusWithHooks';
import userPhoto from '../../../assets/images/boy-face-avatar.webp';
import ProfileDataFormReduxForm from './ProfileDataForm';

const ProfileInfo = (props) => {
    let [editMode, setEditMode] = useState(false);

    if (!props.profile) {
        return <Preloader />
    }
    const onMainPhotoSelected = (e) => {
        if (e.target.files.length) {
            props.savePhoto(e.target.files[0]);
        }
    }

    const onSubmit = (formData) => {
        props.saveProfile(formData)
            .then(()=>{
                setEditMode(false);
            });

    }

    return <div>
        {/*<div>
            <img
                src='https://images.pexels.com/photos/248797/pexels-photo-248797.jpeg?auto=compress&cs=tinysrgb&h=350'/>
        </div>*/}
        <div className={s.descriptionBlock}>
            <div>
                <img src={props.profile.photos.large || userPhoto}/>
            </div>
            {props.isOwner && <input type="file" onChange={onMainPhotoSelected} />}
            {/*<ProfileStatus status={props.status} updateStatus={props.updateStatus} />*/}
            <div>
                Status: <ProfileStatusWithHooks status={props.status} updateStatus={props.updateStatus}/>
            </div>

            { editMode
                ? <ProfileDataFormReduxForm initialValues={props.profile} profile={props.profile} onSubmit={onSubmit} />
                : <ProfileData goToEditMode={ () => {setEditMode(true)} } isOwner={props.isOwner} profile={props.profile} /> }

            <div></div>

        </div>
    </div>
}

const ProfileData = ({profile, isOwner, goToEditMode}) => {
    return <div>
        {isOwner && <div><button onClick={goToEditMode}>edit</button></div>}
        <div>
            Full Name: {profile.fullName}
        </div>
        <div>
            Looking for a job: {profile.lookingForAJob ? "yes" : "no"}
        </div>
        {profile.lookingForAJob &&
        <div>
            My professional skills: {profile.lookingForAJobDescription}
        </div>
        }
        <div>
            About me: {profile.aboutMe}
        </div>
        <div>
            Contacts: {Object.keys(profile.contacts).map(key => {
            return <Contact key={key} contactTitle={key} contactValue={profile.contacts[key]} />
        })}
        </div>
    </div>
}

const Contact = ({contactTitle, contactValue}) => {
    return <div><b>{contactTitle}</b>: {contactValue}</div>
}

export default ProfileInfo;