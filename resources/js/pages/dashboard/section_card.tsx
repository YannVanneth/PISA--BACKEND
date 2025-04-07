import { TrendingDownIcon, TrendingUpIcon } from 'lucide-react';

import { Badge } from '@/components/ui/badge';
import { Card, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

export function SectionCards() {
    return (
        <div className="*:data-[slot=card]:from-primary/5 *:data-[slot=card]:to-card dark:*:data-[slot=card]:bg-card grid grid-cols-2 gap-4 *:data-[slot=card]:bg-gradient-to-t *:data-[slot=card]:shadow-xs lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4 h-fit">
            <Card className="@container/card">
                <CardHeader className="relative">
                    <CardDescription>Active Accounts</CardDescription>
                    <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">45,678</CardTitle>
                    <div className="absolute top-4 right-4">
                        <Badge variant="outline" className="flex gap-1 rounded-lg text-xs">
                            <TrendingUpIcon className="size-3" />
                            +12.5%
                        </Badge>
                    </div>
                </CardHeader>
                <CardFooter className="flex-col items-start gap-1 text-sm">
                    <div className="line-clamp-1 flex gap-2 font-medium">
                        Strong user retention <TrendingUpIcon className="size-4" />
                    </div>
                    <div className="text-muted-foreground">Engagement exceed targets</div>
                </CardFooter>
            </Card>

            <Card className="@container/card">
                <CardHeader className="relative">
                    <CardDescription>Total Recipes</CardDescription>
                    <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">120</CardTitle>
                    <div className="absolute top-4 right-4">
                        <Badge variant="outline" className="flex gap-1 rounded-lg text-xs">
                            <TrendingUpIcon className="size-3" />
                            +12.5%
                        </Badge>
                    </div>
                </CardHeader>
                <CardFooter className="flex-col items-start gap-1 text-sm">
                    <div className="line-clamp-1 flex gap-2 font-medium">
                        Trending up this month <TrendingUpIcon className="size-4" />
                    </div>
                    <div className="text-muted-foreground">Visitors for the last 6 months</div>
                </CardFooter>
            </Card>

            <Card className="@container/card">
                <CardHeader className="relative">
                    <CardDescription>Total Ingredients</CardDescription>
                    <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">45,678</CardTitle>
                    <div className="absolute top-4 right-4">
                        <Badge variant="outline" className="flex gap-1 rounded-lg text-xs">
                            <TrendingUpIcon className="size-3" />
                            +12.5%
                        </Badge>
                    </div>
                </CardHeader>
                <CardFooter className="flex-col items-start gap-1 text-sm">
                    <div className="line-clamp-1 flex gap-2 font-medium">
                        Strong user retention <TrendingUpIcon className="size-4" />
                    </div>
                    <div className="text-muted-foreground">Engagement exceed targets</div>
                </CardFooter>
            </Card>


            <Card className="@container/card">
                <CardHeader className="relative">
                    <CardDescription>Total Recipe Category</CardDescription>
                    <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">45,678</CardTitle>
                    <div className="absolute top-4 right-4">
                        <Badge variant="outline" className="flex gap-1 rounded-lg text-xs">
                            <TrendingUpIcon className="size-3" />
                            +12.5%
                        </Badge>
                    </div>
                </CardHeader>
                <CardFooter className="flex-col items-start gap-1 text-sm">
                    <div className="line-clamp-1 flex gap-2 font-medium">
                        Strong user retention <TrendingUpIcon className="size-4" />
                    </div>
                    <div className="text-muted-foreground">Engagement exceed targets</div>
                </CardFooter>
            </Card>
        </div>
    );
}
