import CardResourceAssign from "./CardResourceAssign"

export default function ListResourceAssign({resources, userid, handleChange}) {
    
    return (
        <ul className="divide-y ">
            { resources?.map(resource => {
                return (
                    <CardResourceAssign 
                        key={`r${resource.id}u${userid}`} 
                        resource={resource} 
                        userId={userid} 
                        onChange={handleChange} 
                    />
                )
            })}
        </ul>
    )
}