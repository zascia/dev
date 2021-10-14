import React from 'react';
import styles from './Users.module.css';
import userPhoto from '../../assets/images/boy-face-avatar.webp';
import {NavLink} from 'react-router-dom';
import {usersAPI} from '../../api/api';

const Users = (props) => {
    let pagesCount = Math.ceil(props.totalUsersCount / props.pageSize);
    let pages = [];

    for (let i=1; i<=pagesCount; i++) {
        pages.push(i);
    }

    return (
        <div>
            <div className={styles.numPageContainer}>
                {pages.map(p => {
                    return <span key={p.id} onClick={ () => {props.onPageChanged(p);} } className={props.currentPage === p && styles.selectedPage}>{p}</span>
                })}
            </div>
            {
                props.users.map(u => <div className={styles.userContainer} key={u.id}>
                    <div>
                        <div>
                            <NavLink to={'/profile/' + u.id}>
                            <img src={ u.photos.small != null ? u.photos.small : userPhoto } className={styles.userPhoto} />
                            </NavLink>
                        </div>
                        <div>
                            {u.followed
                                ? <button disabled={props.followingInProgress.includes(u.id)} onClick={ () => {
                                    props.unfollow(u.id);
                                }}>Unfollow</button>
                                : <button disabled={props.followingInProgress.includes(u.id)} onClick={ () => {
                                    props.follow(u.id);
                                }}>Follow</button>
                                }
                        </div>
                    </div>
                    <div>
                        <div>
                            <div>{u.name}</div>
                            <div>{u.status}</div>
                        </div>
                        <div>
                            <div>{u.location?.country}</div>
                            <div>{u.location?.city}</div>
                        </div>
                    </div>
                </div>)
            }
        </div>
    )
}

export default Users;