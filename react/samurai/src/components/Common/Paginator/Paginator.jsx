import React from 'react';
import styles from './Paginator.module.css';

const Paginator = (props) => {
    let pagesCount = Math.ceil(props.totalUsersCount / props.pageSize);
    let pages = [];

    for (let i=1; i<=pagesCount; i++) {
        pages.push(i);
    }

    return (
            <div className={styles.numPageContainer}>
                {pages.map(p => {
                    return <span key={p.id} onClick={ () => {props.onPageChanged(p);} } className={props.currentPage === p && styles.selectedPage}>{p}</span>
                })}
            </div>

    )
}

export default Paginator;