import BookOpen from "../icons/BookOpen";
import GroupsIcon from "../icons/GroupsIcon";
import UserIcon from "../icons/UserIcon";

export default function CardGroup({group, onSelect}) {

    const handleSelectGroup = () => onSelect(group.id)

    return (
        <div role="button" onClick={handleSelectGroup} className="bg-white rounded-lg border border-gray-300 p-4 shadow-sm hover:shadow-md transition-shadow divide-y gap-4 flex flex-col">
            <div className="flex items-center gap-4">
                <div className="bg-blue-50 rounded-lg p-2">
                    <div className="w-6 h-6 flex items-center justify-center">
                        <GroupsIcon className="w-6 h-6 text-primary" />
                    </div>
                </div>
                <div className="flex-1">
                    <h3 className="font-semibold text-gray-900">{group.name}</h3>
                    <p className="text-gray-500 text-sm">{group.type}</p>
                </div>
            </div>

            <div className="flex items-center justify-between pt-3 text-sm">
                <div className="flex items-center gap-2">
                    <BookOpen className="w-6 h-6 text-yellow-300" />
                    <span className="text-gray-600">{group?.resources?.length ?? 0}</span>
                </div>
                <div className="flex items-center gap-2 text-blue-600">
                    <UserIcon className="w-6 h-6" />
                    <span>{group.users.length ?? 0}</span>
                </div>
            </div>
        </div>
    )
}