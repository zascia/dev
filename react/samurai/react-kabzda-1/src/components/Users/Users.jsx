import React from 'react';
import styles from './Users.module.css';

const Users = (props) => {
    if (props.users.length == 0) {
        props.setUsers([
            {
                id: 1,
                photoUrl: 'https://lh3.googleusercontent.com/proxy/seJM2G1tPNnSa41rAWSCd_mzDGqDaAK6lirtiXJHaZPGeAHcQ3KdGmBCxjS20riAKyJ8EXHk_oiNA25qXxoWQDd-H4APQJapIWwJxchJrhccmRNBDAI1Fo-dDA',
                followed: false,
                fullName: 'Alex brezhnev',
                status: 'Blogger immigration',
                location: {city: 'New york', country: 'USA'}
            },
            {
                id: 2,
                photoUrl: 'https://lh3.googleusercontent.com/proxy/seJM2G1tPNnSa41rAWSCd_mzDGqDaAK6lirtiXJHaZPGeAHcQ3KdGmBCxjS20riAKyJ8EXHk_oiNA25qXxoWQDd-H4APQJapIWwJxchJrhccmRNBDAI1Fo-dDA',
                followed: true,
                fullName: 'Alex Cebu',
                status: 'Blogger consulting',
                location: {city: 'Panglao', country: 'Philippines'}
            },
            {
                id: 3,
                photoUrl: 'https://lh3.googleusercontent.com/proxy/seJM2G1tPNnSa41rAWSCd_mzDGqDaAK6lirtiXJHaZPGeAHcQ3KdGmBCxjS20riAKyJ8EXHk_oiNA25qXxoWQDd-H4APQJapIWwJxchJrhccmRNBDAI1Fo-dDA',
                followed: false,
                fullName: 'Dmitry West',
                status: 'Blogger photo',
                location: {city: 'Moscow', country: 'Russia'}
            }
        ]);
    }

    return (
        <div>
            {
                props.users.map(u => <div className={styles.userContainer} key={u.id}>
                    <div>
                        <div>
                            <img src={u.photoUrl} className={styles.userPhoto} />
                        </div>
                        <div>
                            {u.followed
                                ? <button onClick={ () => {props.unfollow(u.id)} }>Unfollow</button>
                                : <button onClick={ () => { props.follow(u.id)} }>Follow</button>}
                        </div>
                    </div>
                    <div>
                        <div>
                            <div>{u.fullName}</div>
                            <div>{u.status}</div>
                        </div>
                        <div>
                            <div>{u.location.country}</div>
                            <div>{u.location.city}</div>
                        </div>
                    </div>
                </div>)
            }
        </div>
    )
}

export default Users;