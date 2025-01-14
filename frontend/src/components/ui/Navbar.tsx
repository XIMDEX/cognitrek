import Avatar from "./Avatar";

export default function Navbar() {
    return (
        <header className="border-b text-white px-4 py-3 flex justify-between items-center h-[100px] bg-primary">
            <div className="flex items-center gap-4">
            <img 
                src="logotipo_ximdex-white-small.png" 
                alt="Logo Cognitrek" 
                className="w-56"
            />
            </div>
            
            <div className="flex items-center gap-2">
            
            <Avatar image="" user="Fran E" email="fenriqez@ximdex.com" size="sm"/>
            </div>
        </header>
    )
}