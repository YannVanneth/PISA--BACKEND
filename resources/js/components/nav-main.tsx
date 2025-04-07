import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { breadcrumbs } from '@/pages/dashboard';

export function NavMain({ items = [] }: { items: NavItem[]; groupLabel?: string; hasGroupLabel?: boolean }) {
    const page = usePage();
    return (
        <SidebarGroup>
            <SidebarMenu>
                {items.map((item: NavItem) => (
                    <SidebarMenuItem key={item.title}>
                        <SidebarMenuButton asChild isActive={item.href === page.url} tooltip={{ children: item.title }}>
                            <Link href={item.href} prefetch>
                                {item.icon && <item.icon />}
                                <span>{item.title}</span>
                            </Link>
                        </SidebarMenuButton>
                        {item.items?.length ? (
                            <SidebarMenuSub>
                                {item.items.map((item: NavItem) => (
                                    <SidebarMenuSubItem key={item.title}>
                                        <SidebarMenuSubButton asChild isActive={item.isActive}>
                                            <a href={item.href}>{item.title}</a>
                                        </SidebarMenuSubButton>
                                    </SidebarMenuSubItem>
                                ))}
                            </SidebarMenuSub>
                        ) : null}
                    </SidebarMenuItem>
                ))}
            </SidebarMenu>
        </SidebarGroup>
    );
}
