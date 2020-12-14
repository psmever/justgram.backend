import { Model, DataTypes, Optional } from 'sequelize';
import { sequelize } from '@src/instances/Sequelize';

interface UserEmailAuthAttributes {
    id: number;
    user_id: number;
    verify_code: string | null;
}

type UserEmailAuthCreationAttributes = Optional<UserEmailAuthAttributes, 'id'>;

class UserEmailAuth extends Model<UserEmailAuthAttributes, UserEmailAuthCreationAttributes>
    implements UserEmailAuthAttributes {
    public id!: number;
    public user_id!: number;
    public verify_code!: string | null;

    // timestamps!
    public readonly created_at!: Date;
    public readonly updated_at!: Date;
}

UserEmailAuth.init(
    {
        id: {
            type: DataTypes.INTEGER,
            allowNull: false,
            autoIncrement: true,
            primaryKey: true,
        },
        user_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        verify_code: {
            type: DataTypes.STRING,
            allowNull: false,
        },
    },
    {
        tableName: 'user_email_auth',
        sequelize,
        timestamps: false,
    }
);

export default UserEmailAuth;
