import { ChefHat } from 'lucide-react';

export default function AppLogo() {
    return (
        <>
            <div className="ml-1 grid flex-1 text-left text-sm">
                <ChefHat/>
                <span className="mb-0.5 truncate leading-none font-semibold">PISA</span>
            </div>
        </>
    );
}
