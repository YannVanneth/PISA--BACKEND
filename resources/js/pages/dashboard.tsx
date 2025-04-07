import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { ChartAreaInteractive } from '@/pages/dashboard/chart-area-interactive';
import { SectionCards } from '@/pages/dashboard/section_card';

export const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="grid grid-cols-2 h-full flex-col gap-4 rounded-xl px-4 py-2">
                <ChartAreaInteractive />
                <SectionCards data-aos="fade-up"/>
            </div>

        </AppLayout>
    );
}
