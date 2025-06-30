import { XSidebar } from "@ximdex/xui-react/dist";
import { XSidebarProps } from "@ximdex/xui-react/dist/types/components/XSidebar";


export default function Sidebar({items}: XSidebarProps) {
    return (
        <XSidebar items={items} />
    )
}