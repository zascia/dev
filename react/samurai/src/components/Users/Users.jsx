import React from 'react';
import styles from './Users.module.css';
import userPhoto from '../../assets/images/boy-face-avatar.webp';
import {NavLink} from "react-router-dom";
import * as axios from "axios";

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
                                ? <button onClick={ () => {
                                    axios.delete(`https://social-network.samuraijs.com/api/1.0/follow/${u.id}`, {
                                        withCredentials: true,
                                        headers: {
                                            "API-KEY": "e8299a2b-8a8d-4411-9ad1-a439b2235435"
                                        }
                                    })
                                        .then(response => {
                                            if (response.data.resultCode == 0) {
                                                props.unfollow(u.id)
                                            }
                                        });
                                }}>Unfollow</button>
                                : <button onClick={ () => {
                                    axios.post(`https://social-network.samuraijs.com/api/1.0/follow/${u.id}`,{},{
                                        withCredentials: true,
                                        headers: {
                                            "API-KEY": "e8299a2b-8a8d-4411-9ad1-a439b2235435"
                                        }
                                    })
                                        .then(response => {
                                            if (response.data.resultCode == 0) {
                                                props.follow(u.id)
                                            }
                                        });
                                    }
                                }>Follow</button>}
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