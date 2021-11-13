import React from 'react';
import s from './ProfileInfo.module.css';
import Preloader from '../../Common/Preloader/Preloader';
import ProfileStatusWithHooks from './ProfileStatusWithHooks';
import userPhoto from '../../../assets/images/boy-face-avatar.webp';

const ProfileInfo = (props) => {
    if (!props.profile) {
        return <Preloader />
    }
    const onMainPhotoSelected = (e) => {
        if (e.target.files.length) {
            props.savePhoto(e.target.files[0]);
        }
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
            <ProfileStatusWithHooks status={props.status} updateStatus={props.updateStatus}/>
        </div>
    </div>
}

export default ProfileInfo;