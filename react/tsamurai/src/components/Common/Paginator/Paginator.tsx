import React from 'react';
import styles from './Paginator.module.css';

type PropsType = {
    totalUsersCount: number
    pageSize: number
    currentPage: number
    onPageChanged: (p: number) => void
}

const Paginator: React.FC<PropsType> = ({totalUsersCount, pageSize, currentPage, onPageChanged}) => {
    let pagesCount = Math.ceil(totalUsersCount / pageSize);
    let pages = [];

    for (let i=1; i<=pagesCount; i++) {
        pages.push(i);
    }

    return (
            <div className={styles.numPageContainer}>
                {pages.map(p => {
                    return <span key={p} onClick={ () => {onPageChanged(p);} } className={currentPage === p ? styles.selectedPage : ''}>{p}</span>
                })}
            </div>

    )
}

export default Paginator;