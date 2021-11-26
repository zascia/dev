import React from 'react';
import styles from './Users.module.css';
import userPhoto from '../../assets/images/boy-face-avatar.webp';
import {NavLink} from 'react-router-dom';

const User = ({user, followingInProgress, follow, unfollow}) => {
    return (
        <div>
            <div>
                <div>
                    <NavLink to={'/profile/' + user.id}>
                        <img src={user.photos.small != null ? user.photos.small : userPhoto} className={styles.userPhoto}/>
                    </NavLink>
                </div>
                <div>
                    {user.followed
                        ? <button disabled={followingInProgress.includes(user.id)} onClick={() => {
                            unfollow(user.id);
                        }}>Unfollow</button>
                        : <button disabled={followingInProgress.includes(user.id)} onClick={() => {
                            follow(user.id);
                        }}>Follow</button>
                    }
                </div>
            </div>
            <div>
                <div>
                    <div>{user.name}</div>
                    <div>{user.status}</div>
                </div>
                <div>
                    <div>{user.location?.country}</div>
                    <div>{user.location?.city}</div>
                </div>
            </div>
        </div>
    )
}

export default User;