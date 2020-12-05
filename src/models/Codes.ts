/* eslint-disable */
import {
    Sequelize,
    Model,
    ModelDefined,
    DataTypes,
    HasManyGetAssociationsMixin,
    HasManyAddAssociationMixin,
    HasManyHasAssociationMixin,
    Association,
    HasManyCountAssociationsMixin,
    HasManyCreateAssociationMixin,
    Optional,
} from 'sequelize';
import { sequelize } from '@src/instances/Sequelize';

// These are all the attributes in the User model
interface CodesAttributes {
    id: number;
    group_id: string;
    code_id: string | null;
    group_name: string | null;
    code_name: string | null;
    active: 'Y' | 'N';
}

// Some attributes are optional in `User.build` and `User.create` calls
type UserCreationAttributes = Optional<CodesAttributes, 'id'>;

class Codes extends Model<CodesAttributes, UserCreationAttributes> implements CodesAttributes {
    public id!: number; // Note that the `null assertion` `!` is required in strict mode.
    public group_id!: string;
    public code_id!: string | null; // for nullable fields
    public group_name!: string | null; // for nullable fields
    public code_name!: string | null; // for nullable fields
    public active!: 'Y' | 'N';

    // timestamps!
    public readonly created_at!: Date;
    public readonly updated_at!: Date;
}

Codes.init(
    {
        id: {
            autoIncrement: true,
            primaryKey: true,
            type: DataTypes.INTEGER,
        },
        group_id: {
            type: DataTypes.STRING(3),
            allowNull: true,
            defaultValue: null,
        },
        code_id: {
            type: DataTypes.STRING(6),
            defaultValue: null,
            unique: true,
        },
        group_name: {
            type: DataTypes.STRING(100),
            allowNull: true,
            defaultValue: null,
        },
        code_name: {
            type: DataTypes.STRING(100),
            allowNull: true,
            defaultValue: null,
        },
        active: {
            type: DataTypes.ENUM,
            values: ['Y', 'N'],
            allowNull: false,
            defaultValue: 'Y',
        },
    },
    {
        tableName: 'codes',
        sequelize, // passing the `sequelize` instance is required
        timestamps: false,
    }
);

export default Codes;
