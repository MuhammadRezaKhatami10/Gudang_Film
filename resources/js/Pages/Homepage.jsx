import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import MoviesList from '@/Components/Homepage/MoviesList';
import Paginator from '@/Components/Homepage/Paginator';

export default function Homepage(props) {
    return (
        <div className='min-h-screen bg-slate-50'>
            <Head title={props.title} />
            <Navbar user={props.auth.user}/>
            <div className='flex justify-center flex-col lg:flex-row lg:flex-wrap lg:items-stretch
            items-center gap-4 p-4'>
                <MoviesList movies={props.movies.data} />
            </div>
            <div className='flex justify-center item-center'>
                <Paginator meta={props.movies.meta} />
            </div>
        </div>
    )
}