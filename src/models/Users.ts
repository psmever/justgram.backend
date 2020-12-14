import { Model, DataTypes, Optional } from 'sequelize';
import { sequelize } from '@src/instances/Sequelize';

interface UsersAttributes {
    id: number;
    user_uuid: string;
    user_name: string | null;
    user_password: string | null;
    user_email: string | null;
    user_level: string | null;
    active: 'Y' | 'N';
    profile_active: 'Y' | 'N';
    email_verified_at?: Date;
}

type UsersCreationAttributes = Optional<UsersAttributes, 'id'>;

class Users extends Model<UsersAttributes, UsersCreationAttributes> implements UsersAttributes {
    public id!: number;
    public user_uuid!: string;
    public user_level!: string;
    public user_name!: string | null;
    public user_password!: string | null;
    public user_email!: string | null;
    public active!: 'Y' | 'N';
    public profile_active!: 'Y' | 'N';
    public email_verified_at!: Date;

    // timestamps!
    public readonly created_at!: Date;
    public readonly updated_at!: Date;
}

Users.init(
    {
        id: {
            type: DataTypes.INTEGER,
            allowNull: false,
            autoIncrement: true,
            primaryKey: true,
        },
        user_uuid: {
            type: DataTypes.STRING,
            allowNull: false,
            defaultValue: '',
        },
        user_level: {
            type: DataTypes.STRING(6),
            allowNull: false,
            defaultValue: '',
        },
        user_name: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        user_password: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        user_email: {
            type: DataTypes.STRING,
            allowNull: false,
            unique: true,
        },
        active: {
            type: DataTypes.ENUM,
            values: ['Y', 'N'],
            allowNull: false,
            defaultValue: 'Y',
        },
        profile_active: {
            type: DataTypes.ENUM,
            values: ['Y', 'N'],
            allowNull: false,
            defaultValue: 'N',
        },
        email_verified_at: {
            type: DataTypes.DATE,
            allowNull: true,
        },
    },
    {
        tableName: 'users',
        sequelize,
        timestamps: false,
    }
);

export default Users;
